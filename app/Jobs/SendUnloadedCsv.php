<?php

namespace App\Jobs;

use App\Menu;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\DeclareDeclare;

class SendUnloadedCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $from;
    protected $to;

    private $fullTable = [];

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $from
     * @param $to
     */
    public function __construct($user, $from, $to)
    {
        $this->user = $user;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = Str::random(30).'.csv';
        $this->fullTable[] = implode(',', ['id', 'title', 'created_at', 'updated_at']);

        Menu::when($this->from, function ($query, $from){
            $query->where('created_at', '>=', $from);
        })
            ->when($this->to, function ($query, $to){
                $query->where('created_at', '<=', $to);
            })
            ->chunk(Menu::$chunk, function ($menus){
                foreach ($menus as $menu)
                {
                    $this->fullTable[] = implode(',', [$menu->id, $menu->title, $menu->created_at, $menu->updated_at]);
                }
            });
        $path = 'csv/'.now()->format('Y/m/d').'/'.$name;
        $data = implode("\n", $this->fullTable);
        Storage::put($path, $data);
        $this->user->sendPush([
            'status' => 'ok',
            'type' => 'menu.csv',
            'data' => config('filesystems.disks.public.url').'/'.$path,
        ]);
    }
}
