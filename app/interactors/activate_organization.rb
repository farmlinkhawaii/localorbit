class ActivateOrganization
  include Interactor

  def perform
    return unless organization.markets.includes(market)
    return if organization.can_sell?

    if market.auto_activate_organizations?
      organization.update!(active: true, needs_activated_notification: false)
    end
  end
end
