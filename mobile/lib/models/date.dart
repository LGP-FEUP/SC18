import 'package:erasmus_helper/models/model.dart';
import 'package:intl/intl.dart';

class DateModel extends model{
  late int day, month, year;

  DateModel(String date) {
    DateFormat format = DateFormat("dd/MM/yyyy");
    DateTime dt = format.parse(date);
    day = dt.day;
    month = dt.month;
    year = dt.year;
  }

  Map<String, dynamic> toJson() => {'day': day, 'month': month, 'year': year};

  DateModel.fromJson(Map<String, dynamic> json)
      : day = json["day"],
        month = json["month"],
        year = json["year"];
}
