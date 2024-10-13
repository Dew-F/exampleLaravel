@php echo '<?xml version="1.0" encoding="UTF-8"?>' @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/production</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/contacts</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/about</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/news</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/search</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/custom</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/callback</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/cart</loc>
    </url>
    <url>
        <loc>{{ url('/') }}/sitemap.xml</loc>
    </url>
    @foreach ($products as $product)
        <url>
            <loc>{{ url('/') }}/product/{{ $product->slug }}</loc>
        </url>
    @endforeach
    @foreach ($categories as $category)
        <url>
            <loc>{{$category->route}}</loc>
        </url>
    @endforeach
</urlset>
