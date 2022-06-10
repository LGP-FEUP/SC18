import 'package:erasmus_helper/models/date.dart';
import 'package:erasmus_helper/models/model.dart';
import 'package:erasmus_helper/models/time.dart';

class EventModel extends FirebaseModel {
  String? uid;
  String title;
  String author;
  String description;
  String location;
  String cityId;
  DateModel date = DateModel("01/01/1970");
  TimeModel time = TimeModel("00:00");

  EventModel(this.title, this.author, this.description, this.location, this.cityId,
      this.date, this.time);

  @override
  EventModel.fromJson(this.uid, Map<dynamic, dynamic> json) :
      title = json["title"],
      author = json["author"],
      description = json["description"],
      location = json["location"],
      cityId = json["city_id"] {
      final Map<String, dynamic> mapDate =
      (json["date"] as Map<dynamic, dynamic>)
          .map((key, value) => MapEntry(key.toString(), value));
      date = DateModel.fromJson(mapDate);
      final Map<String, dynamic> mapTime =
      (json["time"] as Map<dynamic, dynamic>)
          .map((key, value) => MapEntry(key.toString(), value));
      time = TimeModel.fromJson(mapTime);
  }

  @override
  Map<String, dynamic> toJson() => {
    "title": title,
    "author": author,
    "description": description,
    "location": location,
    "city_id": cityId,
    "date": date.toJson(),
    "time": time.toJson()
  };
}