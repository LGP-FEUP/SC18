import 'package:erasmus_helper/models/model.dart';

class CultureEntry extends FirebaseModel {
  final String uid, title, description, location;
  final List categoryIds;

  CultureEntry(
      this.uid, this.title, this.description, this.location, this.categoryIds);

  CultureEntry.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        location = json['location'],
        categoryIds = (json['categories'] as Map).keys.toList();

  @override
  Map<String, dynamic> toJson() => {
        'title': title,
        'description': description,
        'location': location,
        'categories': categoryIds.map((e) => {e: true})
      };
}
