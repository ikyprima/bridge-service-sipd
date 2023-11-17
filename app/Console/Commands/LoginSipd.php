<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use TokenHelper;

class LoginSipd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:sipd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simpan Info Username dan Password SIPD kemudian di Generate ke dalam bentuk token  ';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payload['username'] = $this->ask('Username SIPD ?');
        $payload['password'] = $this->ask('Password SIPD ?');
        $payload['tahun'] = $this->ask('Tahun ?');
        $payload['idDaerah'] = $this->ask('Id Daerah ?');
        
    

        $token = TokenHelper::createToken($payload);

        Storage::put('token.txt', $token);
        $this->info('Token : '.$token);
        
    }
}
