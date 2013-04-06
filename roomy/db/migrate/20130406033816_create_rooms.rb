class CreateRooms < ActiveRecord::Migration
  def change
    create_table :rooms do |t|
      t.integer :building_id, :null => false
      t.integer :number, :null => false

      t.timestamps
    end
  end
end
