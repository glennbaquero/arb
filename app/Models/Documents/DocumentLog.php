<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;

class DocumentLog extends Model
{
	protected $fillable = [
		'parent_id', 'parent_type', 'document_id', 'status', 'is_supervisor', 'reject_message'
	];

	public function parent()
	{
		return $this->morphTo();	
	}

	public function document()
	{
		return $this->belongsTo(Document::class);	
	}
}
