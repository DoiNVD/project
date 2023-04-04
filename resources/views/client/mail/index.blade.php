<div id="wrapper" style="width:740px;margin:0 auto">
    <table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0"
        style="margin:0;padding:0;background-color:#ffffff;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px"
        width="100%">
        <tbody>
            <tr>
                <td>
                    <h1 style="font-size:18px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Cảm ơn quý khách
                        {{ $fullname }} đã đặt hàng tại {{ $name_store }} Store</h1>

                    <p
                        style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px;font-weight:normal">
                        Vsmart rất vui thông báo đơn hàng {{ $order_code }} của quý khách đã được tiếp nhận và đang
                        trong
                        quá trình
                        xử lý. {{ $name_store }} sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao.</p>

                    <h3
                        style="font-size:14px;font-weight:bold;color:#02acea;text-transform:uppercase;margin:20px 0 0 0;border-bottom:1px solid #ddd">
                        Thông tin đơn hàng {{ $order_code }} <span
                            style="font-size:13px;color:#777;text-transform:none;font-weight:normal">({{ $time }})</span>
                    </h3>
                </td>
            </tr>
            <tr>
                <td style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th align="left"
                                    style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold"
                                    width="50%">Thông tin thanh toán</th>
                                <th align="left"
                                    style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;font-weight:bold"
                                    width="50%"> Địa chỉ giao hàng </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px;font-weight:normal"
                                    valign="top"><span
                                        style="text-transform:capitalize">{{ $fullname }}</span><br>
                                    <a href="mailto:phancuong.qt@gmail.com" target="_blank">{{ $email }}</a><br>
                                    {{ $phone }}
                                </td>
                                <td style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px;font-weight:normal"
                                    valign="top"><span
                                        style="text-transform:capitalize">{{ $fullname }}</span><br>
                                    <a href="mailto:phancuong.qt@gmail.com" target="_blank">{{ $email }}</a><br>
                                    {{ $address }}<br>
                                    Số điện thoại: {{ $phone }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444"
                                    valign="top">
                                    <p
                                        style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px;font-weight:normal">
                                        <strong>Phương thức thanh toán: </strong> Thanh toán tiền mặt khi nhận hàng<br>
                                        <strong>Thời gian giao hàng dự kiến:</strong> Dự kiến giao hàng giao trong vòng từ 3-5 ngày <br>
                                        <strong>Phí vận chuyển: </strong> 0đ<br>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <h2
                        style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:14px;color:#02acea">
                        CHI TIẾT ĐƠN HÀNG</h2>

                    <table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
                        <thead>
                            <tr>
                                <th align="left" bgcolor="#02acea"
                                    style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:14px">
                                    Sản phẩm</th>
                                <th align="left" bgcolor="#02acea"
                                    style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:14px">
                                    Đơn giá</th>
                                <th align="left" bgcolor="#02acea"
                                    style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:14px;text-align:center;">
                                    Số lượng</th>

                                <th align="right" bgcolor="#02acea"
                                    style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:14px">
                                    Tổng tạm</th>
                            </tr>
                        </thead>

                        <tbody bgcolor="#eee"
                        style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px">
                        @foreach (Cart::content() as $item)
                            <tr>
                                <td align="left" style="padding:3px 9px" valign="top"><span>{{ $item->name }}</span><br>
                                </td>
                                <td align="left" style="padding:3px 9px" valign="top"><span>{{ number_format($item->price,0,'.',',') }}đ</span></td>
                                <td align="left" style="padding:3px 9px; text-align:center;" valign="top">{{ $item->qty }}</td>
                                <td align="right" style="padding:3px 9px" valign="top"><span>{{ number_format($item->total,0,'.',',') }}đ</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                        <tfoot
                            style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#444;line-height:18px">
                            <tr>
                                <td align="right" colspan="3" style="padding:5px 9px">Phí vận chuyển</td>
                                <td align="right" style="padding:5px 9px"><span>0đ</span></td>
                            </tr>
                            <tr bgcolor="#eee">
                                <td align="right" colspan="3" style="padding:7px 9px"><strong><big>Tổng giá trị đơn
                                            hàng</big> </strong></td>
                                <td align="right" style="padding:7px 9px"><strong><big><span>{{ Cart::total()}}đ</span> </big>
                                </strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                    <p>Một lần nữa {{ $name_store }} cảm ơn quý khách.</p>
                    <p><strong><a
                                href="{{ url('/') }}">{{ $name_store }}</a>
                        </strong></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
