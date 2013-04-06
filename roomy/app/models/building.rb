# == Schema Information
#
# Table name: buildings
#
#  id         :integer         not null, primary key
#  abbrev     :string(255)     not null
#  name       :string(255)     not null
#  created_at :datetime        not null
#  updated_at :datetime        not null
#

class Building < ActiveRecord::Base
	attr_accessible :abbrev, :name
	has_many :rooms

	# enforce a maximum length?
	validates :abbrev, :name, presence: true, uniqueness: true
end
