class Admin::ReportsController < AdminController
  before_action :restrict_reports, only: :show
  before_action :restrict_buyer_only

  def index
    redirect_to admin_report_path("total-sales")
  end

  def show
    @presenter = ReportPresenter.new(report: @report,
                                     user: current_user,
                                     search: params[:q],
                                     paginate: {
                                       page: params[:page],
                                       per_page: params[:per_page]
                                     })
    respond_to do |format|
      format.html { render "report" }
      format.csv  { @filename = "report.csv" }
    end
  end

  private

  def restrict_buyer_only
    if @report == :purchases_by_product || @report == :total_purchases
      render_404 unless current_user.admin? || current_user.buyer_only?
    else
      render_404 if current_user.buyer_only?
    end
  end

  def restrict_reports
    @report = begin
      if report = ReportPresenter.reports.detect { |r| r == params[:report].to_s.underscore }
        report.to_sym
      else
        render_404
      end
    end
  end
end
