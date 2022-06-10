import 'package:erasmus_helper/models/model.dart';
import 'package:intl/intl.dart';

class TimeModel extends FirebaseModel{
  late int hour, minutes;

  TimeModel(String date) {
    DateFormat format = DateFormat("HH:mm");
    DateTime dt = format.parse(date);
    hour = dt.hour;
    minutes = dt.minute;
  }

  @override
  Map<String, dynamic> toJson() => {'hour': hour, 'minutes': minutes};

  TimeModel.fromJson(Map<String, dynamic> json)
      : hour = json["hour"],
        minutes = json["minutes"];
}
