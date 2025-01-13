<?php
namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    /**
     * Untuk upload data baru
     * @param $file -> tipe UploadFile, berisi file yang akan diupload
     * @param $file_path
     * @param null $name
     * @return array
     * @throws Exception
     */
    public static function upload($file, $file_path, $name = null): array
    {
        if ($name == null) $file_name = time().'-'.$file->getClientOriginalName();
        else $file_name = $name;
        $file_extension = $file->getClientOriginalExtension();
        $res = Storage::cloud()->putFileAs($file_path, $file, $file_name);
        if($res === false){
            throw new \Exception("Gagal upload file!");
        }
        return [
            'file_name' => $file_name,
            'file_extension' => $file_extension,
            'file_path' => $file_path
        ];
    }

    /**
     * Untuk update data -> data sebelumnya akan dihapus dari storage
     * @param $file -> tipe UploadFile, berisi file yang akan diupload
     * @param $file_path -> path lokasi ex contract/filename.docx
     * @param $oldPath -> path file sebelumnya yang akan dihapus (jika file ada)
     * @return array
     * @throws Exception
     */
    public static function reUpload($file, $file_path, $oldPath, $name = null){
        self::delete($oldPath);
        return self::upload($file, $file_path, $name);
    }

    /**
     * Untuk hapus data dari storage
     * @param $path -> path dari lokasi file yang akan dihapus
     * @return void
     * @throws Exception
     */
    public static function delete($path){
        if($path && self::exists($path)){
            Storage::cloud()->delete(urldecode($path));
        }
    }

    /**
     * Untuk mengambil data file dalam bentuk url baru
     * @param $path
     * @return string|null
     * @throws Exception
     */
    public static function getData($path){
        if($path && self::exists($path)){
            return Storage::cloud()->temporaryUrl(urldecode($path), Carbon::now()->addMinutes(5));
        }else{
            return null;
        }
    }


    /**
     * Untuk mengambil data file dalam bentuk url baru
     * @param $path
     * @return string|null
     * @throws Exception
     */
    public static function getDataWithDefault($path){
        $url = self::getData($path);
        return $url !== null
            ? $url
            : 'https://taj.im/wp-content/uploads/2016/02/default.jpg';
    }

    /**
     * Download file if exists
     * @param $path
     * @return string|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public static function download($path){
        if($path && self::exists($path)){
            return Storage::cloud()->download(urldecode($path));
        }else{
            return 'file not found!';
        }
    }

    /**
     * Check file is existing
     * @param $path
     * @return bool
     */
    public static function exists($path){
        return Storage::cloud()->exists(urldecode($path));
    }

    /**
     * @throws Exception
     */
    public static function getDataWithCustomDefault($path, $default_path1 = null, $default_path2 = null): ?string
    {
        // NOTE call function $path = image utama yang mau ditampilkan,
        // NOTE $default_path1 = image kedua jika yg utama tidak ada,
        // NOTE $default_path2 = image ketiga jika yg cadangan tidak ada
        // e.g foto kelas, foto default management, foto kategori
        // e.g foto management, foto default nya || e.g foto student/coach, foto default nya
        $url = self::getData($path);
        if(!$url && $default_path1) $url = self::getData($default_path1);
        if(!$url && $default_path2) $url = self::getData($default_path2);

        // todo ini perlu diubah simpan ke local data nya
        if(!$url) $url = 'https://www.ocregister.com/wp-content/uploads/2017/06/ocr-l-hsacswim-0610-0610_spo_ocr-l-hsacswim_23938356_8090802.jpg?w=802';
        return $url;
    }
}
