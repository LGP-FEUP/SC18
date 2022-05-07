class UserModel {
  final String email, password, fName, lName, facultyOrigin, erasmusFaculty;
  String uid = "";

  UserModel(this.email, this.password, this.fName, this.lName,
      this.facultyOrigin, this.erasmusFaculty);

  Map<String, String> getInfo() {
    return {
      "firstName": fName,
      "lastName": lName,
      "faculty_origin_id": facultyOrigin,
      "faculty_arriving_id": erasmusFaculty
    };
  }
}
