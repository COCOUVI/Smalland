<div class="mb-3">
    <label for="nom" class="form-label">Nom</label>
    <input type="text" name="nom" class="form-control" 
           value="{{ old('nom', $product->nom ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="prix" class="form-label">Prix</label>
        <input type="number" name="prix" class="form-control" 
               value="{{ old('prix', $product->prix ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="qte" class="form-label">Quantité</label>
        <input type="number" name="qte" class="form-control" 
               value="{{ old('qte', $product->qte ?? 0) }}" required>
    </div>
</div>

<div class="mb-3">
    <label for="status_stock" class="form-label">Statut du stock</label>
    <select name="status_stock" class="form-select" required>
        <option value="en_stock" {{ old('status_stock', $product->status_stock ?? '') == 'en_stock' ? 'selected' : '' }}>En stock</option>
        <option value="rupture_de_stock" {{ old('status_stock', $product->status_stock ?? '') == 'rupture_de_stock' ? 'selected' : '' }}>Rupture de stock</option>
    </select>
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Catégorie</label>
    <select name="category_id" class="form-select" required>
        <option value="">-- Choisir une catégorie --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" 
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nom }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="path_img" class="form-label">Image</label>
    <input type="file" name="path_img" class="form-control">
    @if(isset($product) && $product->path_img)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $product->path_img) }}" alt="Image" width="100" class="rounded shadow">
        </div>
    @endif
</div>
