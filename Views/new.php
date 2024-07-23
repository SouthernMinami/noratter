<?php

namespace Views;

?>

<div class="title-container">
    <h1 class="page-title">NEW POST</h1> 
    <div class="d-flex flex-column p-4 m-3 w-50 border border-secondary rounded upload-container">
        <label for="upload-file" >Upload Image here<br/>(* JPG/JPEG/PNG/GIF, max 4MB)</label>
        <label class="pb-3">
            <span class="btn btn-primary px-5 py-3">
                <i class="fas fa-upload"></i>
                UPLOAD
                <input type="file" id="upload-file" accept=".jpg, .jpeg, .png, .gif" class="pb-3 upload-file" style="display:none"/>        
            </span>
        </label>    
        <div id="upload-error" style="display: none;">            
            <p class="text-danger upload-error"></p>
        </div>
        <label for="post-title">Title</label>
        <input type="text" id="post-title" class="mb-3 w-75" placeholder="eg. My cat (* max 25 characters)" maxlength="25"/>
        <label for="preview">Image Preview</label>
        <div id="preview" class="pb-3 preview">
            <img id="preview-img" class="img-fluid preview-img"/>
        </div>
        <label for="post-description">Description</label>
        <textarea id="post-description" placeholder="eg. My cat is cute. (* max 255 characters)" maxlength="255" class="mb-3 b-3"></textarea>
        <button id="upload-button" class="btn btn-success" onClick="postImage()">POST</button>
    </div>     
</div>
<script src="/public/js/app_new.js"></script>