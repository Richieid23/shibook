<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new User;
        $administrator->username = 'administrator';
        $administrator->name = 'Site Administrator';
        $administrator->email = 'administrator@shibook.test';
        $administrator->roles = json_encode(['ADMIN']);
        $administrator->password = Hash::make('shibook');
        $administrator->avatar = 'saat-ini-tidak-ada-file.png';
        $administrator->address = 'Sarmili, Bintaro, Tangerang Selatan';

        $administrator->save();

        $this->command->info('User Admin berhasil diinsert');
    }
}
