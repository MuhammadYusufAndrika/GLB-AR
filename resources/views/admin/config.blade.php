@extends('admin.layouts.app')

@section('title', 'Server Configuration')

@section('content')
<div class="page-header">
    <h1 class="page-title">Server Configuration</h1>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">PHP Upload Settings</h2>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Setting</th>
                <th>Current Value</th>
                <th>Recommended</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>upload_max_filesize</code></td>
                <td><strong>{{ ini_get('upload_max_filesize') }}</strong></td>
                <td>60M</td>
                <td>
                    @php
                        $upload_max = (int) ini_get('upload_max_filesize');
                        $is_ok = $upload_max >= 60;
                    @endphp
                    @if($is_ok)
                        <span class="badge badge-success">✓ OK</span>
                    @else
                        <span class="badge badge-danger">✗ Too Low</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><code>post_max_size</code></td>
                <td><strong>{{ ini_get('post_max_size') }}</strong></td>
                <td>65M</td>
                <td>
                    @php
                        $post_max = (int) ini_get('post_max_size');
                        $is_ok = $post_max >= 65;
                    @endphp
                    @if($is_ok)
                        <span class="badge badge-success">✓ OK</span>
                    @else
                        <span class="badge badge-danger">✗ Too Low</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><code>max_execution_time</code></td>
                <td><strong>{{ ini_get('max_execution_time') }}s</strong></td>
                <td>300s</td>
                <td>
                    @php
                        $exec_time = (int) ini_get('max_execution_time');
                        $is_ok = $exec_time >= 300 || $exec_time === 0;
                    @endphp
                    @if($is_ok)
                        <span class="badge badge-success">✓ OK</span>
                    @else
                        <span class="badge badge-warning">Low</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><code>memory_limit</code></td>
                <td><strong>{{ ini_get('memory_limit') }}</strong></td>
                <td>256M</td>
                <td>
                    @php
                        $mem_limit = (int) ini_get('memory_limit');
                        $is_ok = $mem_limit >= 256 || $mem_limit === -1;
                    @endphp
                    @if($is_ok)
                        <span class="badge badge-success">✓ OK</span>
                    @else
                        <span class="badge badge-warning">Low</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">How to Increase Upload Limits</h2>
    </div>

    <div style="padding: 1rem;">
        <h3 style="margin-bottom: 1rem; font-size: 1rem;">For Development (php artisan serve):</h3>
        
        <div style="background: var(--dark); padding: 1rem; border-radius: var(--radius); margin-bottom: 1.5rem; overflow-x: auto;">
            <code style="color: var(--success); white-space: pre;">php -d upload_max_filesize=60M -d post_max_size=65M -d memory_limit=256M artisan serve</code>
        </div>

        <h3 style="margin-bottom: 1rem; font-size: 1rem;">For Production (Apache/Nginx):</h3>
        
        <p style="margin-bottom: 1rem; color: var(--text-muted);">Edit your php.ini file:</p>
        <div style="background: var(--dark); padding: 1rem; border-radius: var(--radius); margin-bottom: 1.5rem; overflow-x: auto;">
            <pre style="margin: 0; color: var(--text);"><code>upload_max_filesize = 60M
post_max_size = 65M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M</code></pre>
        </div>

        <p style="color: var(--text-muted); font-size: 0.875rem;">
            After making changes, restart your web server and refresh this page.
        </p>
    </div>
</div>
@endsection
