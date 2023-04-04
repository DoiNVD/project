<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait StorageImageTrait
{
    // Các phương thức của trait
    public function storageTraitUpload($request, $filename, $folder)
    {
        if ($request->hasFile($filename)) {
            $file = $request->$filename;
            $fileNameOriginal = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameOriginal, PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();
            $fullname = time() . '-' . Str::slug($fileName) . "." . $fileExtension;
            $file->move(public_path("storage/" . $folder . "/" . Auth::id()), $fullname);
            $path = "/public/storage/" . $folder . "/" . Auth::id() . "/" . $fullname;
            return $path;
        }
        return null;
    }
    public function storageTraitUploadMultiple($file, $folder)
    {
        //lấy ra tên gốc của file được upload.
        $fileNameOriginal = $file->getClientOriginalName();
       // sử dụng hàm pathinfo() để lấy tên của file gốc bằng cách bỏ đi phần mở rộng ở cuối
        $fileName = pathinfo($fileNameOriginal, PATHINFO_FILENAME);
        // trả về extension/đuôi file gốc của file được upload, ví dụ .jpg, .png ...
        $fileExtension = $file->getClientOriginalExtension();
        //ghép các giá trị lấy được ở trên để tạo tên file mới, sao cho nó không bị trùng với bất kỳ file nào trong cùng thư mục
        $fullname = time() . '-' . Str::slug($fileName) . "." . $fileExtension;
        $file->move(public_path("storage/" . $folder . "/" . Auth::id()), $fullname);
        $path = "/public/storage/" . $folder . "/" . Auth::id() . "/" . $fullname;
        return $path;
    }
}

