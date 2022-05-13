import 'package:erasmus_helper/models/date.dart';

class UserModel {
  final String fName, lName, facultyOrigin, erasmusFaculty;
  late DateModel birthdate;
  String uid = "";
  String? email, password;
  List<String> doneTasks;

  UserModel(
      this.email,
      this.password,
      this.fName,
      this.lName,
      this.facultyOrigin,
      this.erasmusFaculty,
      String birthdate,
      this.doneTasks) {
    this.birthdate = DateModel(birthdate);
  }

  UserModel.fromJson(Map<String, dynamic> json)
      : fName = json['firstname'],
        lName = json['lastname'],
        facultyOrigin = json['faculty_origin_id'],
        erasmusFaculty = json['faculty_arriving_id'],
        doneTasks = json['doneTasks'] ?? List.generate(0, (index) => "") {
    final Map<String, dynamic> map =
        (json["date_of_birth"] as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value));
    birthdate = DateModel.fromJson(map);
  }

  Map<String, dynamic> toJson() => {
        'id': uid,
        'firstname': fName,
        'lastname': lName,
        'faculty_origin_id': facultyOrigin,
        'faculty_arriving_id': erasmusFaculty,
        "date_of_birth": birthdate.toJson(),
        "validation_level": "1"
      };
}
