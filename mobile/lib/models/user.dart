import 'package:erasmus_helper/models/date.dart';

class UserModel {
  final String fName, lName, facultyOrigin, erasmusFaculty;
  late DateModel birthdate;
  String? email, password, fName, lName, facultyOrigin, erasmusFaculty;
  String? description, countryCode, phone, whatsapp, facebook;
  List<String?>? interests = [];
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
  UserModel(
    this.email,
    this.password,
    this.fName,
    this.lName,
    this.facultyOrigin,
    this.erasmusFaculty, {
    this.description,
    this.countryCode,
    this.phone,
    this.whatsapp,
    this.facebook,
    this.interests,
  });

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
  UserModel.profile(
      this.fName,
      this.lName,
      this.facultyOrigin,
      this.erasmusFaculty,
      this.description,
      this.countryCode,
      this.phone,
      this.whatsapp,
      this.facebook,
      this.interests);

  Map<dynamic, dynamic> toJson() => <dynamic, dynamic>{
        "firstName": fName,
        "lastName": lName,
        "faculty_origin_id": facultyOrigin,
        "faculty_arriving_id": erasmusFaculty,
        "description": description,
        "country_code": countryCode,
        "phone": phone,
        "whatsapp": whatsapp,
        "facebook": facebook,
        "interests": interests,
      };

  UserModel.fromJson(Map<dynamic, dynamic> json)
      : fName = json["firstName"],
        lName = json["lastName"],
        facultyOrigin = json["faculty_origin_id"],
        erasmusFaculty = json["faculty_arriving_id"],
        description = json["description"],
        countryCode = json["country_code"],
        phone = json["phone"],
        whatsapp = json["whatsapp"],
        facebook = json["facebook"],
        interests = json["interests"];
}
