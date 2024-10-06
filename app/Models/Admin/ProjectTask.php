<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $table = "project_tasks";

    protected $fillable = ["detail", "date", "created_by", "project_id", "status"];
}
