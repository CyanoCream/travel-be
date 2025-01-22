<?php

namespace App\Models;

use App\Services\StorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblProductPicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'picture',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function product(): BelongsTo
    {
        return $this->belongsTo(TblProduct::class);
    }

    public static function deletePicture($id)
    {
        try {
            $picture = TblProductPicture::findOrFail($id);

            // Delete the file using StorageService
            StorageService::delete($picture->picture);

            // Delete the database record
            $picture->delete();

            return response()->json(['success' => 'Gambar berhasil dihapus']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menghapus gambar: ' . $e->getMessage()], 500);
        }
    }
    public function showImage(){
        return StorageService::getData($this->photo);
    }
}
