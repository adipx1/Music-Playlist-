document.querySelector("form").addEventListener("submit", function(e) {
    const title = document.querySelector("[name='title']").value.trim();
    const artist = document.querySelector("[name='artist']").value.trim();
    if (!title || !artist) {
        alert("Semua field harus diisi!");
        e.preventDefault();
    }
});
