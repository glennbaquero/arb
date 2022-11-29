<?php

namespace App\Models\Documents;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Users\User;

use App\Traits\ImageTrait;

class Document extends Model
{

    protected $appends = [ 'bg_image', 'application_type', 'is_image' ];

    use ImageTrait;
    
	const PENDING = 0;
	const APPROVED = 1;
	const REJECTED = 2;

	/**
	 * Get the indexable data array for the model.
	 *
	 * @return array
	 */
	public function toSearchableArray() {
	    return [
	        'id' => $this->id,
	        'file_name' => $this->file_name,
	        'file_type' => $this->file_type,
	    ];
	}

    /**
     * Relationship
     */
    
    public function user()
    {
    	return $this->belongsTo(User::class)->withTrashed();
    }

    public function documentLogs()
    {
        return $this->hasMany(DocumentLog::class);
    }

    /**
     * @Getters
     */
    public static function getTypes() {
    	return [
    		['value' => static::PENDING, 'label' => 'Pending', 'description' => '', 'class' => 'bg-info'],
    		['value' => static::APPROVED, 'label' => 'Approved', 'description' => '', 'class' => 'bg-primary'],
    		['value' => static::REJECTED, 'label' => 'Rejected', 'description' => '', 'class' => 'bg-danger'],
    	];
    }

    /**
     * @Render
     */
    
    public function renderType($column = 'label', $isAdmin = true) {

        if(!$isAdmin) {
            return static::renderConstants(static::getTypes(), $this->supervisor_approval_status, $column);
        }
        
        return static::renderConstants(static::getTypes(), $this->status, $column);
    }

        /*
	|--------------------------------------------------------------------------
	| @Renders
	|--------------------------------------------------------------------------
	*/

    /**
     * Render show url for specific item
     * 
     * @return string/route
     */
	public function renderShowUrl($prefix = 'admin') 
    {
        $route = $this->id;
        $name = 'documents.show';

        return route($prefix . ".{$name}", $route);
    }

    /**
     * Render archive url for specific item
     * 
     * @return string/route
     */
    public function renderArchiveUrl($prefix = 'admin') 
    {
        return route($prefix . '.documents.archive', $this->id);
    }

    /**
     * Render archive url for specific item
     * 
     * @return string/route
     */
    public function renderRestoreUrl($prefix = 'admin') 
    {
        return route($prefix . '.documents.restore', $this->id);
    }

    /**
     * Render approved url for specific item
     * 
     * @return string/route
     */
    public function renderApprovedUrl($prefix = 'admin') 
    {
        return route($prefix . '.documents.update', $this->id.'?approval_status=1');
    }

    /**
     * Render reject url for specific item
     * 
     * @return string/route
     */
    public function renderRejectUrl($prefix = 'admin') 
    {
        return route($prefix . '.documents.update', $this->id.'?approval_status=2');
    }

    /**
     * Append bg image full path
     *
     * @return string $result
     */
    public function getBgImageAttribute()
    {
        $type = $this->file_type;
        $result = url('mobile/images.svg');

        if($type === 'pdf') {
            $result = url('mobile/pdf.svg');
        } elseif ($type === 'xlxs' || $type ==='xls' || $type ==='csv' || $type ==='ods' || $type ==='xlsb' || $type ==='xlsm' || $type ==='xlsx' || $type ==='xml' || $type === 'xps') {
            $result = url('mobile/xlxs.svg');
        } elseif ($type === 'docx' || $type === 'doc' || $type === 'odt') {
            $result = url('mobile/docs.svg');
        } elseif ($type === 'odp' || $type ==='potm' || $type ==='potx' || $type ==='ppa' || $type ==='ppam' || $type ==='pps' || $type ==='ppsm' || $type ==='ppt' || $type ==='pptx') {
            $result = url('mobile/powerpoint.svg');
        }

        return $result;
    }

    /**
     * Append application type
     *
     * @return string $result
     */
    public function getApplicationTypeAttribute()
    {
        $type = $this->file_type;
        $result = '';

        if($type === 'pdf') {
            $result = 'PDF';
        } elseif ($type === 'xlxs' || $type ==='xls' || $type ==='csv' || $type ==='ods' || $type ==='xlsb' || $type ==='xlsm' || $type ==='xlsx' || $type ==='xml' || $type === 'xps') {
            $result = 'Excel';
        } elseif ($type === 'docx' || $type === 'doc' || $type === 'odt') {
            $result = 'Word';
        } elseif ($type === 'odp' || $type ==='potm' || $type ==='potx' || $type ==='ppa' || $type ==='ppam' || $type ==='pps' || $type ==='ppsm' || $type ==='ppt' || $type ==='pptx') {
            $result = 'Powerpoint';
        } elseif ($type === 'jpeg' || $type === 'jpg' || $type === 'png' || $type === 'heic') {
            $result = 'Image';
        }

        return $result;
    }

    /**
     * Append application type
     *
     * @return string $result
     */
    public function getIsImageAttribute()
    {
        $type = $this->file_type;
        $result = false;

        if ($type === 'jpeg' || $type === 'jpg' || $type === 'png' || $type === 'heic') {
            $result = true;
        }

        return $result;
    }
}
