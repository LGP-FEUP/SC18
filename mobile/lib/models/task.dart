class TaskModel {
  final String? uid, description, facultyId, title, dueDate;

  TaskModel(
      this.uid, this.title, this.description, this.dueDate, this.facultyId);

  TaskModel.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        dueDate = json['due_date'],
        facultyId = json['faculty_id'];

  static TaskModel fromJsonMap(MapEntry<dynamic, dynamic> json) {
    return TaskModel.fromJson(
        json.key.toString(),
        (json.value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value)));
  }
}

class StepModel {
  final String? title, uid;

  StepModel(this.uid, this.title);
}
