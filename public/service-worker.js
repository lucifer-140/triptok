self.addEventListener('install', function(event) {
    event.waitUntil(
      caches.open('my-cache').then(function(cache) {
        return cache.addAll([
          '/',
          '/css/app.css',
          '/js/app.js',
          '/icon-192x192.png',
        ]);
      })
    );
  });

  self.addEventListener('fetch', function(event) {
    event.respondWith(
      caches.match(event.request).then(function(cachedResponse) {
        return cachedResponse || fetch(event.request);
      })
    );
  });
