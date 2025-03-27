Your order

Cart list:

<ul>
    @foreach($data[0] as $item)
        <li>{{$item->product_name}} - {{($item->price)}} đ - {{$item->quantity}} - {{($item->price*$item->quantity)}} đ</li>
    @endforeach
</ul>

