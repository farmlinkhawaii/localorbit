module ProductImport
  module FileImporters
    class Cooks < Framework::FileImporter

      format :xlsx

      stage :extract do |s|
        # s.transform :from_flat_table,
        #   headers: true

        # s.transform :validate_keys_are_present,
        #   keys: %w(item desc gname brandname)
      end

      stage :canonicalize do
        # transform :translate_keys, map: {
        #   "item" => "product_code",
        #   "desc" => "name",
        #   "gname" => "category",
        # }

        # transform :join_keys,
        #   into: "name",
        #   keys: %w(brandname desc)

        # transform :lookup_or_create_category,
        #   column: "gname",
        #   map_file: "cooks_categories.yml"

      end

    end
  end
end

