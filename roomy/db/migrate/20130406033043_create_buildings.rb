class CreateBuildings < ActiveRecord::Migration
  def change
    create_table :buildings do |t|
      t.string :abbrev, :null => false
      t.string :name, :null => false

      t.timestamps
    end
  end
end
