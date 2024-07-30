const deletePost = () => {
    const formData = new FormData()
    formData.append("deletePath", image["delete_path"])
    fetch("/Helpers/deletePost.php", {
        method: "POST",
        body: formData
    }) 
    .then((res) => res.json())
    .then((data) => {
        if (data["status"] === "success") {
            alert("Post deleted successfully")
            window.location.href = "/new"
        } else {
            alert("Post deletion failed")
        }
    })
    .catch((error) => console.error(error))
}
