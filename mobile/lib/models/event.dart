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
  DateModel date;
  TimeModel time;

  EventModel(this.title, this.author, this.description, this.location, this.cityId,
      this.date, this.time);

  EventModel.fromJson(this.uid, Map<dynamic, dynamic> json) :
      title = json["title"],
      author = json["author"],
      description = json["description"],
      location = json["location"],
      cityId = json["cityId"],
      date = DateModel.fromJson(json["date"]),
      time = TimeModel.fromJson(json["time"]);

  @override
  Map<String, dynamic> toJson() => {
    "title": title,
    "author": author,
    "description": description,
    "location": location,
    "cityId": cityId,
    "date": date.toJson(),
    "time": time.toJson()
  };
}