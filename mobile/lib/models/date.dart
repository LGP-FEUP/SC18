import 'package:erasmus_helper/models/model.dart';
import 'package:intl/intl.dart';

class DateModel extends FirebaseModel{
  late int day, month, year;

  DateModel(String date) {
    DateFormat format = DateFormat("dd/MM/yyyy");
    DateTime dt = format.parse(date);
    day = dt.day;
    month = dt.month;
    year = dt.year;
  }

  @override
  Map<String, dynamic> toJson() => {'day': day, 'month': month, 'year': year};

  @override
  DateModel.fromJson(Map<String, dynamic> json){
    print(json);
    day = json["day"];
    month = json["month"];
    year = json["year"];
    print(day);
    print(month);
    print(year);
  }


}
