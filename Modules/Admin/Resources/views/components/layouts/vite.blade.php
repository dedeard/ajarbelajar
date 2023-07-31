@props(['path' => ''])

{{ \Vite::useHotFile(public_path('admin.hot'))->useBuildDirectory('build/admin')->withEntryPoints([$path]) }}
