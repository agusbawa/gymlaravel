<?php

use Illuminate\Database\Seeder;

class FakeGymsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker\Factory::create('id_ID');
        App\User::create([
                'username' => "",
                'phone' => "",
                'remember_token' => "",
                'email' => "frankyso.mail@gmail.com",
                'password' => bcrypt("1q2w3e"),
                'avatar' => '',
            ]);

        // // Zona
        // for($i = 0; $i < 10; $i++) {
        //     App\Zona::create([
        //         'title'         => $faker->name,
        //         'updated_at'    => $faker->dateTime,
        //         'created_at'    => $faker->dateTime,
        //     ]);
        // }

        // // Gym
        // for($i = 0; $i < 10; $i++) {
        //     App\Gym::create([
        //         'title' => $faker->name,
        //         'address' => $faker->address,
        //         'location_latitude' => $faker->latitude,
        //         'location_longitude' => $faker->longitude,
        //         'zona_id'           => rand ( 1 , 10 )
        //     ]);

        //     echo "Gym Added ".$i;
        //     echo "/n";
        // }

        // // // Cards
        // for($i = 0; $i < 5000; $i++) {
        //     $card   = new App\Card;   
        //     $card->save();
        //     echo "Card Added ".$i;
        //     echo "/n";
        // }

        // // // Package
        // for($i = 0; $i < 5; $i++) {
        //     $package                = new App\Package;
        //     $package->title         = $faker->name;   
        //     $package->save();
        //     echo "Package Added ".$i;
        //     echo "/n";
        // }

        // Members
        // foreach (App\Gym::get() as $key => $gym) {
        //     $item   =   rand ( 10 , 20 );
        //     for($i = 0; $i < $item; $i++) {
        //         App\Member::create([
        //             'name'              => $faker->name,
        //             'slug'              => $faker->slug,
        //             'nick_name'         => $faker->name,
        //             'address_street'    => $faker->streetName,
        //             'address_region'    => $faker->citySuffix,
        //             'address_city'      => $faker->city,
        //             'phone'             => '88888888',
        //             'email'             => $faker->freeEmail,
        //             'password'          => $faker->password,
        //             'job'               => str_limit($faker->jobTitle,30) ,
        //             'gym_id'            => $gym->id,
        //             'updated_at'        => $faker->dateTime,
        //             // 'created_at'        => $faker->dateTime,
        //             'extended_at'       => $faker->dateTime,
        //             'expired_at'        => $faker->dateTime,
        //             'facebook_url'      =>'',
        //             'twitter_url'       =>'',
        //             'instagram_url'     =>'',
        //             'hobby'             =>'',
        //             'status'            =>'ACTIVE',
        //             'package_id'        =>'1',
        //             'place_of_birth'    =>$faker->citySuffix,
        //             'date_of_birth'     =>$faker->dateTimeBetween('-50 years','-18 years'),
        //             'gender'            =>array('MALE','FEMALE')[rand(0,1)]
        //         ]);
        //         echo "Member Added ".$i;
        //         echo "/n";
        //     }
        // }
    }
}
