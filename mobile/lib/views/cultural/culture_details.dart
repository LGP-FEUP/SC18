import 'package:erasmus_helper/models/cultureEntry.dart';
import 'package:erasmus_helper/views/cultural/components/culture_details_background.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CultureDetails extends StatelessWidget {
  final CultureEntry entry;

  const CultureDetails(this.entry, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Provider<CultureEntry>.value(
        value: entry,
        child: Stack(
          children: <Widget>[
            CultureDetailsBackground(),
            //CultureDetailsContent(entry),
          ],
        ),
      ),
    );
  }
}
