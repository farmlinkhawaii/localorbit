class Document < ActiveRecord::Base
  belongs_to :user
  dragonfly_accessor :doc_pdf
end
