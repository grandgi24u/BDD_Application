*Preparation de la seance 2*

Question 1

Categorie(!id, nom, descr)
Annonce(!id, titre, date, texte)
CategorieAnnonce(!#id_categorie, !#id_annonce)
Photo(!id, file, date, taille_octet, #annonce_id)

Question 2

- Le fichier Annonce.php :

$this->hasMany('\TD2\modele\Photo', 'annonce_id') 

- Le fichier Photo.php :

$this->belongsTo('\TD2\modele\Annonce', 'annonce_id')

Question 3

3.1
Annonce::where('id', '=', 22)->first()->hasMany('\TD2\modele\Photo', 'annonce_id')->get()

3.2
Annonce::where('id', '=', 22)->first()->hasMany('\TD2\modele\Photo', 'annonce_id')->where('taille_octet', '>', 100000)->get()

3.3
Annonce::where($this->hasMany('\TD2\modele\Photo', 'annonce_id')->get()->count(),'>', 3)->get()

3.4
Annonce::where($this->hasMany('\TD2\modele\Photo', 'annonce_id')->where('taille_octet', '>', 100000)->get()->count(),'>', 0)->get()

Question 4

$annonce = Annonce::where('id', '=', 22)->first()
$photo = new Photo();
$photo->save();
$annonce->hasMany('\TD2\modele\Photo', 'annonce_id')->save($photo)

Question 5
