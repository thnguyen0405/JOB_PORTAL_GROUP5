<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvCertificate extends Model
{
    protected $table = 'cv_certificates';

    protected $fillable = [
        'cv_id',
        'certificate_name_id',
        'issuing_organization_id',
        'year_issued',
        'description',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

    public function certificateName()
    {
        return $this->belongsTo(CertificateName::class);
    }

    public function issuingOrganization()
    {
        return $this->belongsTo(IssuingOrganization::class);
    }
}