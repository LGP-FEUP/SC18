class Tag {
  String title;

  Tag(this.title);

  Tag.fromJson(Map<dynamic, dynamic> json) : title = json["title"];

  Map<String, bool> toJson() => <String, bool>{title: true};

  Tag.fromString(String string) : title = string;
}
