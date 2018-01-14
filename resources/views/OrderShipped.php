<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    
    protected $name;
    protected $order;
    protected $tel;
    protected $email;
    protected $city;
    protected $pricegoods;
    protected $priceall;
    protected $comment;
    protected $hash;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $hash, $path_redirect)//(Order $order)
    {
        $this->name = $name;
        $this->hash = $hash;
        $this->path_redirect = $path_redirect;
        // $this->title = $title;
        // $this->tel = $tel;
        // $this->email = $email;
        // $this->city = $city;
        // $this->pricegoods = $pricegoods;
        // $this->priceall = $priceall;
        // $this->comment = $comment;
        // $this->sizeTitle = $sizeTitle;
        // $this->colorTitle = $colorTitle;
        // $this->nid = $nid;
        // $this->priceone = $priceone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');

        return $this->from('money@bazabd.xyz')
                ->view('mail.emailAdmin')
                ->with([
                        'name' => $this->name,
                        'hash' => $this->hash,
                        'path_redirect' => $this->path_redirect,
                        // 'title' => $this->title,
                        // 'tel' => $this->tel,
                        // 'email' => $this->email,
                        // 'city' => $this->city,
                        // 'pricegoods' => $this->pricegoods,
                        // 'priceall' => $this->priceall,
                        // 'comment' => $this->comment,
                        // 'sizeTitle' => $this->sizeTitle,
                        // 'colorTitle' => $this->colorTitle,
                        // 'nid' => $this->nid,
                        // 'priceone' => $this->priceone,
                    ]);
    }
}
