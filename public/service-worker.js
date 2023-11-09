// En tu archivo service-worker.js
self.addEventListener('install', event => {
    event.waitUntil(
      caches.open('v1').then(cache => {
        return cache.addAll([
          '/',
          '/css/app.css',
          '/js/app.js',
          // Lista otros recursos que quieres cachear
        ]);
      })
    );
  });

  self.addEventListener('fetch', event => {
    event.respondWith(
      caches.match(event.request).then(response => {
        return response || fetch(event.request);
      })
    );
  });
