class PostModel {
  String uid, author;
  String? image, body;

  PostModel(this.uid, this.author, this.body, this.image);

  PostModel.fromJson(this.uid, Map<String, dynamic> json)
      : author = json['author'] {
    if (json['image'] != null) {
      image = json['image'];
    }
    if (json['body'] != null) {
      body = json['body'];
    }
  }
}
