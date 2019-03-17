<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {
    public function run() {

      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Artisan::call('migrate:refresh', ['--force' => true,]);
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      Model::unguard();

      \App\Region::insert(['regionName' => "Default Region", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\Site::insert(['siteName' => "Default Site", 'address' => "Plot 807, Block E Phase 1 Johar Town, Lahore, Punjab, Pakistan", 'lng' => "74.29515874", 'lat' => "31.46894483", 'rad' => "300.00", 'region_id' => "1", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\Fence::insert(['fenceName' => "Fence 1", 'address' => "Plot 864, Block E Phase 1 Johar Town, Lahore, Punjab, Pakistan", 'lng' => "74.29554498", 'lat' => "31.46868861", 'rad' => "30.00", 'site_id' => "1", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      //'Super', 'Manager', 'Valet', 'Customer'
      \App\User::insert([ 'name' => "Super", 'email' => "super@enviro.com", 'type' => 'Super', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png', 'region_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\User::insert([ 'name' => "Manager", 'email' => "manager@enviro.com", 'type' => 'Manager', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png', 'region_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\User::insert([ 'name' => "Valet", 'email' => "valet@enviro.com", 'type' => 'Valet', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png', 'region_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\User::insert([ 'name' => "Customer", 'email' => "customer@enviro.com", 'type' => 'Customer', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png', 'region_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\Photo::insert(['photoType' => "Violation", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\Photo::insert(['photoType' => "General", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\Infraction::insert(['infractionName' => "Loose Trash", 'priority' => "3", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      \App\Violation::insert(['infraction_id' => null, 'fence_id' => "1", 'user_id' => "3", 'unitNumber' => "A369", 'photo_id' => "1", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);
      
      \App\Violation::insert(['infraction_id' => "1", 'fence_id' => "1", 'user_id' => "3", 'unitNumber' => "A369", 'photo_id' => "2", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]);

      //'infraction_id', 'fence_id', 'user_id', 'image', 'unitNumber', 'photo_id'

      Model::reguard();
    }
}
