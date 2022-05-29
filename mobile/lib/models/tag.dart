import 'package:erasmus_helper/models/model.dart';

class Tag extends FirebaseModel {
  String title;

  Tag(this.title);

  Tag.fromJson(Map<dynamic, dynamic> json) : title = json["title"];

  @override
  Map<String, bool> toJson() => <String, bool>{title: true};

  Tag.fromString(String string) : title = string;

  @override
  int get hashCode => title.hashCode;

  @override
  bool operator ==(Object other) {
    return hashCode == other.hashCode;
  }

  static List<Tag> interestsFromJson(Map<dynamic, dynamic> json) {
    List<Tag> tags = [];
    json.forEach((key, value) {
      if (value) {
        tags.add(Tag.fromString(key));
      }
    });
    return tags;
  }

  static Map<String, bool> interestsToJson(List<Tag> interests) {
    Map<String, bool> map = {};
    for (var element in interests) {
      map.addAll(element.toJson());
    }
    return map;
  }
}
