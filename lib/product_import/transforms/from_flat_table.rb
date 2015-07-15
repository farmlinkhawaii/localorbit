class ProductImport::Transforms::FromFlatTable < ProductImport::Framework::Transform
  def initialize(opts={})
    super

    # Future proof for providing static header list
    raise ArgumentError unless opts[:headers] == true

    # If true, don't preserve unlabeled values. (Whose header is blank0
    @drop_unlabeled = opts[:drop_unlabeled]

    # If provided, these fields must be in the header.
    # Presence on rows is NOT defined
    @required_keys = opts[:required_keys] || []

    # Used to track if any required headers were missing
    @missing_keys = nil
  end

  # Use the first row as keys. Subsequent rows
  # get the column entries as values.
  # By default, any blank column entries get values
  # associated with their index, unless drop_unlabeled
  # is true.
  def transform_step(row)
    if @header
      if @missing_keys
        reject "Missing keys #{@missing_keys.join(", ")}"
        return
      end

      hash = Hash[@header.zip(row)]
      hash.delete nil

      unless @drop_unlabeled
        row.each.with_index do |v, i|
          unless @header[i]
            hash[i] = v
          end
        end
      end

      continue hash

    else
      @header = row.map {|v|
        if v.blank?
          nil
        else
          v
        end
      }

      missing = @required_keys - @header
      if missing.size > 0
        @missing_keys = missing
      end

    end
  end
end
