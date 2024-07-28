const fileInput = document.getElementById('upload-file')
const uploadErrorMsg = document.getElementById('upload-error')
const previewImage = document.getElementById('preview-img')

window.onload = () => {
    // file inputのアップロード状態とエラーメッセージの表示をリセット
    fileInput.value = ''
    uploadErrorMsg.style.display = 'none' 
}

fileInput.addEventListener('change', (e) => {
    uploadErrorMsg.style.display = 'none'
    previewImage.src = ''

    // キャンセルを押した場合は、ファイルアップロードをリセット
    if (e.target.files.length === 0) {
        return
    }
    
    const reader = new FileReader()
    const file = e.target.files[0]
    // サイズが4MB以下なら、画像ファイルを読み込みbase64形式に変換して、resultに格納
    if (file.size < 4000000) {
        reader.readAsDataURL(file)    
        // file readerのロード時に、previewImageのsrcにreaderのresult属性を代入
        reader.onload = () => {
        previewImage.src = reader.result
    }
    } else {
        // 4MBより大きければエラーメッセージを表示
        uploadErrorMsg.style.display = 'block'
        uploadErrorMsg.textContent = 'Please upload file less than 4MB'
        uploadErrorMsg.classList.add('text-danger')
    }
})

const postImage = () => {    
    const file = fileInput.files[0]
    // 画像が選択されていない場合は、エラーメッセージを表示
    if (!file || file.size > 4000000) {
        console.log('error')
        uploadErrorMsg.style.display = 'block'
        uploadErrorMsg.textContent = 
            !file ? 'Please select an image above' : 'Please upload file less than 4MB'
        uploadErrorMsg.classList.add('text-danger')
        return
    }

    const title = document.getElementById('post-title').value
    const description = document.getElementById('post-description').value

    const formData = new FormData()
    formData.append('title', title)
    formData.append('description', description)
    formData.append('file', file)

    fetch('/Helpers/postImage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data)
        window.location.href = '/image/' + data['postPath']
    })
    .catch(error => console.error(error))
}