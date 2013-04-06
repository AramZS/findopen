# == Schema Information
#
# Table name: rooms
#
#  id          :integer         not null, primary key
#  building_id :integer         not null
#  number      :integer         not null
#  created_at  :datetime        not null
#  updated_at  :datetime        not null
#

class Room < ActiveRecord::Base
  attr_accessible :number
  belongs_to :building

  validates :number, presence: true, numericality: { only_integer: true, greater_than_or_equal_to: 0 }
end
