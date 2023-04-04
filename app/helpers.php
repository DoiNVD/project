<?php

use App\Models\category_product;
use App\Models\Menu;
//Xuất dữ liệu đa cấp menu, danh mục với thuật toán ĐỆ QUY
// tạo menu đa cấp từ một cấu trúc dữ liệu có cây phân cấp sử dụng đệ quy để duyệt các phần tử trong mảng dữ liệu và xác định các phần tử con của chúng
function multi_level_menu($data, $parent_id = 0, $level = 0)
{
    $result = array();
    foreach ($data as $item) {
        if ($item->parent_id == $parent_id) {
            $item['level'] = $level;
            $result[] = $item;
            // unset($data[$item['id']]);
            $child = multi_level_menu($data, $item->id, $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}

function main_menu()
{
    $main_menu = Menu::where('status', 1)->limit(8)->get();
    return $main_menu;
}


function getCatParent($id)
{
    $cat = category_product::find($id);
    return $cat;
}

// show mảng

function show_array($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
}
