class User < ActiveRecord::Base
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable
  devise :invitable, :database_authenticatable, #:registerable,
         :recoverable, :rememberable, :trackable, :validatable

  has_many :managed_markets_join, class_name: 'ManagedMarket'
  has_many :managed_markets, through: :managed_markets_join, source: :market do
    def can_manage_organization?(org)
      joins(:organizations).where({organizations: {id: org.id}}).exists?
    end
  end

  has_many :user_organizations
  has_many :organizations, through: :user_organizations

  def admin?
    role == 'admin'
  end

  def can_manage_organization?(org)
    admin? || managed_markets.can_manage_organization?(org)
  end

  def market_manager?
    managed_markets.any?
  end

  def managed_organizations
    if admin?
      Organization.all
    elsif market_manager?
      Organization.
        select("DISTINCT organizations.*").
        joins("LEFT JOIN user_organizations ON user_organizations.organization_id = organizations.id
               LEFT JOIN market_organizations ON market_organizations.organization_id = organizations.id").
        where(["user_organizations.user_id = ? OR market_organizations.market_id IN (?)", id, managed_markets_join.map(&:market_id)])
    else
      organizations
    end
  end

  def markets
    if admin?
      Market.all
    elsif market_manager?
      Market.
        select("DISTINCT markets.*").
        joins("LEFT JOIN market_organizations ON market_organizations.market_id = markets.id
               LEFT JOIN user_organizations ON user_organizations.organization_id = market_organizations.organization_id
               LEFT JOIN managed_markets ON managed_markets.market_id = markets.id").
        where(["user_organizations.user_id = ? OR managed_markets.user_id = ?", id, id])
    else
      Market.
        select("DISTINCT markets.*").
        joins("INNER JOIN market_organizations ON market_organizations.market_id = markets.id
               INNER JOIN user_organizations ON user_organizations.organization_id = market_organizations.organization_id").
        where("user_organizations.user_id" => id)
    end
  end

  def managed_products
    if admin?
      Product.all
    else
      org_ids = managed_organizations.pluck(:id).uniq
      Product.where(organization_id: org_ids)
    end
  end
end
