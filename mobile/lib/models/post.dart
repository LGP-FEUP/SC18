import 'package:erasmus_helper/models/model.dart';

class PostModel extends FirebaseModel {
  String author;
  String? uid, image, body;
  int time;

  PostModel(this.author, this.time, this.body);

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

  Map<String, dynamic> toJson() => {
    'author': author,
    'time': time,
    'body': body
  };
}
