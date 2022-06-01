import 'package:flutter/material.dart';

class CultureCategory {
  final String categoryId;
  final String title;
  final IconData icon;

  CultureCategory(this.categoryId, this.title, this.icon);

  CultureCategory.fromJson(this.categoryId, Map<String, dynamic> json)
      : title = json['title'],
        icon = Icons.add;

  Map<String, dynamic> toJson() => {
        'title': title,
      };
}
