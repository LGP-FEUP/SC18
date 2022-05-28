class PostModel {
  String uid, author;
  String? image, body;
  int time;

  PostModel(this.uid, this.author, this.time, this.body, this.image);

  PostModel.fromJson(this.uid, Map<String, dynamic> json)
      : author = json['author'],
        time = json['time'] {
    if (json['image'] != null) {
      image = json['image'];
    }
    if (json['body'] != null) {
      body = json['body'];
    }
  }
}
