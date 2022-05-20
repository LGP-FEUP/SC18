import 'package:erasmus_helper/models/cultureEntry.dart';
import 'package:flutter/material.dart';

class EntryWidget extends StatelessWidget {
  final CultureEntry entry;

  const EntryWidget({Key? key, required this.entry}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 4,
      color: Colors.white,
      child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: Column(children: <Widget>[
            ClipRRect(
                borderRadius: BorderRadius.circular(30),
                child: Image.asset(
                  entry.imagePath,
                  height: 150,
                )),
          ])),
    );
  }
}
