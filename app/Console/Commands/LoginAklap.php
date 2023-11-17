<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TokenHelper;
use Illuminate\Support\Facades\Storage;
class LoginAklap extends Command
{
    //info username dan password aklap
    /**
     * The name and signature of the console command. 
     *
     * @var string
     */
    protected $signature = 'login:aklap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simpan Info Username dan Password AKLAP kemudian di Generate ke dalam bentuk token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payload['username'] = $this->ask('Username AKLAP ?');
        $payload['password'] = $this->ask('Password AKLAP ?');
        $payload['tahun'] = $this->ask('Tahun ?');
        $payload['idDaerah'] = $this->ask('Id Daerah ?');
        
        $token = TokenHelper::createToken($payload);

        Storage::put('token_aklap.txt', $token);
        $this->info('Token : '.$token);
    }
}
