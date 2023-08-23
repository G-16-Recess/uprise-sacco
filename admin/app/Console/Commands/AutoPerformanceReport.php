<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\PerformanceMail;

class AutoPerformanceReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send auto performance email to active users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = ['erwakasiisi@gmail.com', 'edwin.nyongozi@gmail.com'];
        $data = [
            'subject' => 'Uprise performance report',
            'body' => 'Greetings dear member of Uprise Sacco. Here is how our sacco performed this month',
        ];
        try {
            for ($i = 0; $i < count($users); $i++) {
                Mail::to($users[$i])->send(new PerformanceMail($data));
            }
            return response()->json(['Great check your mail box']);
        } catch (Exception $th) {
            return response()->json(['Sorry']);
        }
        return 0;
    }
}

