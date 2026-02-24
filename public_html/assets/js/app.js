document.querySelectorAll('img[loading="lazy"]').forEach(img=>{img.addEventListener('error',()=>{img.src='/assets/img-placeholder.jpg';});});
