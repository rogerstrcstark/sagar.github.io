<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactEmails extends Model
{
    protected $table='contact_emails';
    protected $fillable=['name','image','description','email_address','status','trash','created_by','updated_by'];
}
