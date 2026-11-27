
<style>
    /* CSS untuk tampilan form */
    .form-container {
        width: 100%;
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        text-align: center;
    }
    .form-container h4 {
        margin-bottom: 10px;
        font-size: 20px;
        color: #333;
    }
    .form-container p {
        font-size: 14px;
        color: #666;
    }
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .btn-submit {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }
    .btn-submit:hover {
        background-color: #0056b3;
    }
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <h4>Verifikasi NISN</h4>
    <p>Masukkan NISN Anda untuk mendownload data.</p>
    
    <form action="{{ route('download', $data->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nisn">NISN</label>
            <input type="text" id="nisn" name="nisn" required>
            @error('nisn')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Download Data</button>
    </form>
</div>

