<!-- hiển thị đường dẫn dẫn từ danh mục con (ví dụ: Tiểu thuyết) đến danh mục cha -->

<!-- //Nếu $cat không phải là danh mục gốc (tức là không có đối tượng cha), 
//đoạn mã sẽ gọi hàm getCatParent() để lấy đối tượng cha của $cat, 
thêm vào mảng $listCat và đệ quy gọi lại chính nó với đối tượng cha $catParent. -->
@if ($cat->parent_id != 0)
@php
$catParent = getCatParent($cat->parent_id);
$listCat[] = $catParent;
@endphp
@include('components.cat_parent', ['cat' => $catParent, 'listCat' => $listCat])
@else
@for ($i = count($listCat) - 1; $i >= 0; $i--)
<li>
    <a href="" title="">{{ $listCat[$i]->name }}</a>
</li>
@endfor
@endif