export default class SimpleUploadAdapter {
    constructor(loader, uploadUrl) {
        this.loader = loader;
        this.uploadUrl = uploadUrl;
    }

    upload() {
        return this.loader.file.then(
            (file) =>
                new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append("images", file);
                    data.append("width", 600);
                    data.append("quality", 80);

                    const token =
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "";

                    fetch(this.uploadUrl, {
                        method: "POST",
                        body: data,
                        headers: {
                            "X-CSRF-TOKEN": token,
                        },
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result && result.url) {
                                this.uploadedImageUrl = result.url;
                                resolve({ default: result.url });
                            } else {
                                reject(result?.message || "Upload failed");
                            }
                        })
                        .catch((error) => {
                            reject(error?.message || "Upload failed");
                        });
                })
        );
    }

    abort() {}
}
