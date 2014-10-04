class CreateDocuments < ActiveRecord::Migration
  def change
    create_table :documents do |t|
      t.integer "user_id"
      t.string "doc_pdf_uid"
      t.string "doc_pdf_name"
      t.string "note"
      t.timestamps
    end
  end
end
