import 'package:flutter/material.dart';

class CultureCategory {
  final String categoryId;
  final String title;
  final IconData icon;

  CultureCategory(this.categoryId, this.title, this.icon);

  CultureCategory.fromJson(this.categoryId, Map<String, dynamic> json)
      : title = json['title'],
        icon = IconData(json['icon'], fontFamily: 'MaterialIcons');

  Map<String, dynamic> toJson() => {'title': title, "icon": icon.codePoint};
}
